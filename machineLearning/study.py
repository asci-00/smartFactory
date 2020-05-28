import numpy as np

import matplotlib.pyplot as plt

from PIL import Image

np.random.seed(3)



from tensorflow.keras.preprocessing.image import ImageDataGenerator



train_datagen = ImageDataGenerator(rescale=1./255,

                                  rotation_range=10,

                                  width_shift_range=0.2,

                                  height_shift_range=0.2,

                                  shear_range=0.7,

                                  zoom_range=[0.9,2.2],

                                  horizontal_flip=True,

                                  vertical_flip=True,

                                  fill_mode='nearest')



train_generator = train_datagen.flow_from_directory('./embeddedlab/train', target_size=(24,24,),batch_size=3,class_mode='categorical')





test_datagen = ImageDataGenerator(rescale=1./255)



test_generator = test_datagen.flow_from_directory('./embeddedlab/test', target_size=(24,24,),batch_size=3,class_mode='categorical')



from tensorflow.keras.models import Sequential

from tensorflow.keras.layers import Dense

from tensorflow.keras.layers import Flatten

from tensorflow.keras.layers import Conv2D

from tensorflow.keras.layers import MaxPooling2D





#모델 구성하기

model = Sequential()



model.add(Conv2D(32, kernel_size=(3,3), activation='relu', input_shape=(24,24,3)))

model.add(Conv2D(64,(3,3), activation='relu'))

model.add(MaxPooling2D(pool_size=(2,2)))

model.add(Flatten())

model.add(Dense(128,activation='relu'))

model.add(Dense(2,activation='softmax'))



#모델 엮기

model.compile(loss='categorical_crossentropy', optimizer='adam', metrics=['accuracy'])



#모델 학습시키기

model.fit_generator(train_generator, steps_per_epoch=15, epochs=100, validation_data=test_generator, validation_steps=5)



#결과

print("-- Evaluate --")



scores = model.evaluate_generator(test_generator, steps=5)



print("%s: %.2f%%" %(model.metrics_names[1], scores[1]*100))





#정확도

print("-- Predict --")



output = model.predict_generator(test_generator, steps=5)



np.set_printoptions(formatter={'float' : lambda x : "{0:0.3f}".format(x)})



print(output)

from tensorflow.keras.models import load_model

model.save('embed_model.h5')





